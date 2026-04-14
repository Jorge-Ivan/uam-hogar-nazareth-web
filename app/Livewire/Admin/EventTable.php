<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\Event;
use App\Services\EventService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Livewire component for the admin events listing table.
 *
 * Provides search, pagination, and delete confirmation for Event records.
 */
final class EventTable extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    /** @var array<string> */
    protected $queryString = ['search'];

    public string $search = '';

    #[Locked]
    public ?int $deleteId = null;

    private EventService $eventService;

    /**
     * Resolve services via Livewire boot — constructor injection is not supported by ComponentRegistry.
     */
    public function boot(EventService $eventService): void
    {
        $this->eventService = $eventService;
    }

    /**
     * Reset pagination when search changes.
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Set the event ID pending deletion confirmation.
     */
    public function confirmDelete(int $id): void
    {
        $this->deleteId = $id;
    }

    /**
     * Cancel the pending deletion.
     */
    public function cancelDelete(): void
    {
        $this->deleteId = null;
    }

    /**
     * Permanently delete the event after confirmation.
     */
    public function deleteEvent(): void
    {
        if ($this->deleteId === null) {
            return;
        }

        $event = Event::find($this->deleteId);

        if ($event) {
            $this->authorize('delete', $event);
            $this->eventService->delete($event);
        }

        $this->deleteId = null;

        session()->flash('success', 'Evento eliminado.');
    }

    public function render(): View
    {
        $events = Event::query()
            ->with('featuredImage')
            ->when($this->search, fn ($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->orderBy('start_date', 'desc')
            ->paginate(15);

        return view('livewire.admin.event-table', ['events' => $events]);
    }
}
