<?php

namespace App\View\Components;

use App\Models\Tour;
use Illuminate\View\Component;

class BookingModal extends Component
{
    /**
     * Create a new component instance.
     */
    public $programs;
    public $selectedProgramId;

    public function __construct($selectedProgramId = null)
    {
        $this->programs = Tour::all()
            ->map(function ($program) {
                return [
                    'id' => $program->id,
                    'title' => $program->title,
                    'packet' => $program->packet,
                ];
            })
            ->toArray();

        $this->selectedProgramId = $selectedProgramId;
    }

    public function render()
    {
        return view('components.booking-modal');
    }
}
