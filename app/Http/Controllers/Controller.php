<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return to_route('admin.auth.login');
    }

    public function saveContent(Request $request)
    {
        if (empty($request->title) || empty($request->description)) {
            return back()->with('message', 'All fields are required.');
        }
        $content = Content::where('ref_key', strip_tags($request->ref_key))->first();
        $content->title = strip_tags($request->title);
        $content->description = strip_tags($request->description);
        $content->img_path = strip_tags($request->input('img_path', $content->img_path));
        $content->save();

        return back()->with('success', 'Content saved successfully');
    }

    public function getdownlines($array, $parent = 0, $level = 0)
    {
        $referedMembers = '';
        foreach ($array as $entry) {
            if ($entry->reffered_by == $parent) {
                if ($level === 0) {
                    $levelQuote = 'Direct referral';
                } else {
                    $levelQuote = "Indirect referral level {$level}";
                }

                $referedMembers .= "
                  <tr>
                  <td> {$entry->name} </td> 
                  <td> {$levelQuote} </td>" .
                    '<td>' . $this->getUserParent($entry->id) . '</td>' .
                    '<td>' . $this->getUserStatus($entry->id) . '</td>
                  <td>' . $this->getUserRegDate($entry->id) . '</td>
                  </tr>';

                $referedMembers .= $this->getdownlines($array, $entry->id, $level + 1);
            }

            if ($level === 6) {
                break;
            }
        }
        return $referedMembers;
    }

    public function ref(Request $request, $referral_id)
    {
        if (isset($referral_id)) {
            $request->session()->flush();
            if (User::firstWhere('username', $referral_id)) {
                $request->session()->put('ref_by', $referral_id);
            }
            return redirect()->route('register');
        }
    }

    //Get user Parent
    private function getUserParent($id)
    {
        $user = User::where('id', $id)->first();
        $parent = User::where('id', $user->reffered_by)->first();
        if ($parent) {
            return "{$parent->name}";
        }
        return 'null';
    }

    //Get user status
    private function getUserStatus($id)
    {
        $user = User::where('id', $id)->first();

        return $user->status->value;
    }

    //Get User Registration Date
    private function getUserRegDate($id)
    {
        $user = User::where('id', $id)->first();

        return $user->created_at->format('D d M, Y');
    }
}