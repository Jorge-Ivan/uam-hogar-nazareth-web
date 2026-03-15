<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\Page;
use App\Services\PageService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

/**
 * Livewire component for creating and editing admin Pages.
 *
 * Handles auto-slug generation, validation, draft saving,
 * and publishing via PageService.
 */
final class PageForm extends Component
{
    public string $title = '';

    public string $slug = '';

    public string $content = '';

    public string $status = 'draft';

    public ?int $pageId = null;

    public function __construct(
        private readonly PageService $pageService,
    ) {}

    /**
     * Populate form fields when editing an existing page.
     */
    public function mount(?Page $page = null): void
    {
        if ($page && $page->exists) {
            $this->pageId  = $page->id;
            $this->title   = $page->title;
            $this->slug    = $page->slug;
            $this->content = $page->content;
            $this->status  = $page->status->value;
        }
    }

    /**
     * Auto-generate the slug from the title on create only.
     */
    public function updatedTitle(string $value): void
    {
        if (! $this->pageId) {
            $this->slug = Str::slug($value);
        }
    }

    /**
     * Save as draft (create or update) and redirect to index.
     */
    public function save(): void
    {
        $this->validate($this->rules());

        if ($this->pageId) {
            $page = Page::findOrFail($this->pageId);
            $this->pageService->update($page, [
                'title'   => $this->title,
                'slug'    => $this->slug,
                'content' => $this->content,
                'status'  => $this->status,
            ]);
        } else {
            $this->pageService->create([
                'title'   => $this->title,
                'slug'    => $this->slug,
                'content' => $this->content,
                'status'  => $this->status,
            ]);
        }

        session()->flash('success', 'Página guardada.');

        $this->redirect(route('admin.pages.index'), navigate: false);
    }

    /**
     * Publish the page after saving and redirect to index.
     */
    public function publish(): void
    {
        $this->validate($this->rules());

        if ($this->pageId) {
            $page = Page::findOrFail($this->pageId);
            $this->pageService->update($page, [
                'title'   => $this->title,
                'slug'    => $this->slug,
                'content' => $this->content,
                'status'  => $this->status,
            ]);
        } else {
            $page = $this->pageService->create([
                'title'   => $this->title,
                'slug'    => $this->slug,
                'content' => $this->content,
                'status'  => $this->status,
            ]);
        }

        $this->pageService->publish($page);

        session()->flash('success', 'Página publicada.');

        $this->redirect(route('admin.pages.index'), navigate: false);
    }

    public function render(): View
    {
        return view('livewire.admin.page-form');
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        $uniqueSlug = Rule::unique('pages', 'slug');

        if ($this->pageId) {
            $uniqueSlug = $uniqueSlug->ignore($this->pageId);
        }

        return [
            'title'   => ['required', 'string', 'max:255'],
            'slug'    => ['required', 'string', 'max:255', 'regex:/^[a-z0-9-]+$/', $uniqueSlug],
            'content' => ['required', 'string'],
            'status'  => ['required', 'in:draft,published,archived'],
        ];
    }
}
