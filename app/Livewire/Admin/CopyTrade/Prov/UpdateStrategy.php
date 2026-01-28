<?php

namespace App\Livewire\Admin\CopyTrade\Prov;

use App\Models\SymbolMap;
use App\Services\TradeCopier;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class UpdateStrategy extends Component
{
    use LivewireAlert;

    public $account;
    public $strategy_name;
    public $strategy_description;
    public $stra_com;
    public $commission_type;
    public $billing_period;
    public $commission_rate;
    public $strategy_mode = 'none';
    public $publish_to_telegram;
    public $modecompliment;
    public $chat_id;
    public $bot_token;
    public $modeInfo;
    public $optionTitle;
    public $modes = [
        'none' => 'none',
        'contractSize' => 'contractSize',
        'balance' => 'balance',
        'equity' => 'equity',
        'fixedVolume' => 'fixedVolume',
        'fixedRisk' => 'fixedRisk',
        'expression' => 'expression',
    ];

    public function mount(TradeCopier $copier, string $id): void
    {
        $accountCollections = collect($copier->providers());

        $this->account = $accountCollections->first(function ($accounts) use ($id) {
            return $accounts['id'] === intval($id);
        });
        //dd($this->account);
        $this->fill($this->account);
        $this->publish_to_telegram = $this->account['publish_to_telegram'] === 0 ? false : true;
    }

    public function render()
    {
        return view('livewire.admin.copy-trade.prov.update-strategy');
    }

    public function save(TradeCopier $copier): void
    {
        if ($this->strategy_mode === 'fixedRisk' || $this->modecompliment === 'fixedVolume' || $this->modecompliment === 'expression') {
            $modeCompliment = $this->modecompliment;
        } else {
            $modeCompliment = '';
        }

        $payload = [
            'account_id' => $this->account['id'],
            'mode' => $this->strategy_mode,
            'strategy_name' => $this->strategy_name,
            'description' => $this->strategy_description,
            'modecompliment' => $modeCompliment,
            'publish' => [
                'publish' => $this->publish_to_telegram,
                'token' => $this->bot_token,
                'chatId' => $this->chat_id,
                'template' => 'FxTrader: ${description}',
            ],
        ];
        // get all symbolmaps and check if its not empty and convert both the from_symbol and to_symbol to array
        $symbolMaps = SymbolMap::select('from_symbol', 'to_symbol')->get();
        if ($symbolMaps) {
            $maps = $symbolMaps->map(function ($map) {
                return [
                    'to' => $map->to_symbol,
                    'from' => $map->from_symbol,
                ];
            })->toArray();
            $payload['symbolMapping'] = $maps;
        }

        try {
            $message = $copier->updateStrategy($payload);
            $this->alert(message: $message);
            $this->dispatch('refresh-prov-accounts');
        } catch (\App\Exceptions\CopytradeErrorException $e) {
            $this->alert(type: 'error', message: $e->getMessage());
        }
    }
}