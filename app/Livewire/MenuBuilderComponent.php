<?php

namespace App\Livewire;

use App\Models\Menu;
use Livewire\Component;

class MenuBuilderComponent extends Component
{
    public $menus;

    public function mount()
    {
        $this->loadMenus();
    }

    public function loadMenus()
    {
        $this->menus = Menu::with('children')
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();
    }

    public function updateOrder($order)
    {
        if (!is_array($order)) {
            $order = json_decode($order, true);
        }

        foreach ($order as $item) {
            Menu::where('id', $item['id'])->update([
                'parent_id' => $item['parent_id'],
                'sort_order' => $item['sort_order'],
            ]);
        }

        $this->loadMenus();

        session()->flash('message', 'Menu updated successfully!');
    }

    public function save()
    {
        session()->flash('message', 'Menu saved!');
    }

    public function render()
    {
        return view('livewire.menu-builder-component');
    }
}