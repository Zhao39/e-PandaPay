<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Settings;
use App\Services\Website;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File as ArchiveFile;
use Illuminate\Validation\Rules\File;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class DashboardAppearance extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $theme_file;
    public $theme;
    public $themes;
    public $website_theme;
    public $set;

    public function mount(): void
    {
        $set = Cache::get('site_settings');
        $this->theme = $set->theme;
        $this->themes = $set->themes;
        $this->website_theme = $set->website_theme;
        $this->set = $set;
    }

    public function render()
    {
        return view('livewire.admin.settings.dashboard-appearance');
    }

    public function saveTheme(): void
    {
        Settings::find(1)->update(['theme' => $this->theme]);
        Cache::forget('site_settings');
        activity()->log('Changed theme to ' . $this->theme);
        $this->alert(message: 'Settings Saved Successfully.');
    }

    public function updateColour(Website $website): void
    {
        $this->set->update(['website_theme' => $this->website_theme]);
        Cache::forget('site_settings');
        $website->clearCache(type: 'views');
        activity()->log('Changed website theme to ' . $this->website_theme);
        $this->flash(message: 'Colour Saved Successfully', redirect: route('admin.settings.appearance'));
    }

    public function addTheme(): void
    {
        $this->validate(
            [
                'theme_file' => [
                    'required',
                    File::types(['zip'])
                        ->min('1kb')
                        ->max('70mb'),
                ],
            ]
        );

        $file = $this->theme_file;

        // read the content of the zip file
        $zip = new \ZipArchive();

        $open = $zip->open($file->getRealPath());

        //get theme name without the .zip extension
        $themeName = substr($file->getClientOriginalName(), 0, -4);

        if (! in_array($themeName, ['dashly', 'front', 'qudash', 'veuxy'])) {
            $this->alert(type: 'error', message: 'Invalid theme name, allowed names are: dashly, front, qudash & veuxy');
            return;
        }

        // check if the theme already exists
        $themes = $this->set->themes;

        if (in_array($themeName, $themes) || $themeName === 'purpose' || $themeName === 'millage') {
            $this->alert(type: 'error', message: 'Theme already exists');
            return;
        }

        try {
            if ($open) {
                // extract the zip file to the views folder
                $zip->extractTo(base_path("resources/views/{$themeName}"));
                $zip->close();

                // move the assets folder inside this theme folder to the public directory
                if (ArchiveFile::exists(resource_path("views/{$themeName}/assets"))) {
                    ArchiveFile::copyDirectory(resource_path("views/{$themeName}/assets"), public_path("themes/{$themeName}/assets"));
                    ArchiveFile::deleteDirectory(resource_path("views/{$themeName}/assets"));
                }

                if (ArchiveFile::exists(resource_path("views/{$themeName}/layouts"))) {
                    ArchiveFile::copyDirectory(resource_path("views/{$themeName}/layouts"), resource_path('views/layouts'));
                    ArchiveFile::deleteDirectory(resource_path("views/{$themeName}/layouts"));
                }

                if (ArchiveFile::exists(resource_path("views/{$themeName}/__MACOSX"))) {
                    ArchiveFile::deleteDirectory(resource_path("views/{$themeName}/__MACOSX"));
                }

                $themes = array_merge($themes, [$themeName]);
                $this->set->themes = $themes;
                $this->set->save();
                Cache::forget('site_settings');
                (new Website())->clearCache('views');
                activity()->log('Added new theme ' . $themeName);
                $this->flash(message: 'Theme uploaded successfully', redirect: route('admin.settings.appearance'));
            }
        } catch (\Throwable $th) {
            $this->alert(type: 'error', message: $th->getMessage() ?? 'Error uploading theme, please try again');
        }
    }

    public function deleteTheme()
    {
        try {
            $theme = $this->theme;
            $themes = $this->set->themes;

            if (ArchiveFile::exists(public_path("themes/{$theme}"))) {
                ArchiveFile::deleteDirectory(public_path("themes/{$theme}"));
            }

            if (ArchiveFile::exists(resource_path("views/{$theme}"))) {
                ArchiveFile::deleteDirectory(resource_path("views/{$theme}"));
            }

            if (file_exists(resource_path("views/layouts/{$theme}.blade.php"))) {
                unlink(resource_path("views/layouts/{$theme}.blade.php"));
            }

            if (in_array($theme, $themes)) {
                $themes = array_diff($themes, [$theme]);
                $this->set->themes = $themes;
                $this->set->save();
                Cache::forget('site_settings');
            }

            (new Website())->clearCache('views');
            activity()->log('Deleted theme ' . $theme);

            $this->flash(message: 'Theme deleted successfully', redirect: route('admin.settings.appearance'));
        } catch (\Throwable $th) {
            $this->alert(type: 'error', message: $th->getMessage() ?? 'Error deleteing theme, please try again');
        }
    }
}