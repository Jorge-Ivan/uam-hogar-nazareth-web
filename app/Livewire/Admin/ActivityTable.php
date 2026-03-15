<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Enums\ContentStatus;
use App\Models\Activity;
use App\Services\ActivityService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Livewire component for the admin activities listing table.
 *
 * Provides search, status filtering, pagination, inline publishing,
 * and soft-delete confirmation for Activity records.
 */
final class ActivityTable extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    /** @var array<string> */
    protected $queryString = ['search', 'statusFilter'];

    public string $search = '';

    public string $statusFilter = '';

    #[Locked]
    public ?int $deleteId = null;

    public function __construct(
        private readonly ActivityService $activityService,
    ) {}

    /**
     * Reset pagination when search changes.
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Reset pagination when status filter changes.
     */
    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    /**
     * Set the activity ID pending deletion confirmation.
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
     * Permanently delete the activity after confirmation.
     */
    public function deletePage(): void
    {
        if ($this->deleteId === null) {
            return;
        }

        $activity = Activity::find($this->deleteId);

        if ($activity) {
            $this->authorize('delete', $activity);
            $this->activityService->delete($activity);
        }

        $this->deleteId = null;

        $this->dispatch('notify', message: 'Actividad eliminada.');
    }

    /**
     * Publish a single activity inline from the table.
     */
    public function publishActivity(int $id): void
    {
        $activity = Activity::findOrFail($id);

        $this->authorize('update', $activity);

        $this->activityService->publish($activity);

        $this->dispatch('notify', message: 'Actividad publicada.');
    }

    public function render(): View
    {
        $activities = Activity::query()
            ->with('featuredImage')
            ->when($this->search, fn ($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->latest()
            ->paginate(15);

        return view('livewire.admin.activity-table', ['activities' => $activities]);
    }
}
