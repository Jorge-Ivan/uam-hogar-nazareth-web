<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Enums\ContentStatus;
use App\Models\Media;
use App\Models\Page;
use App\Services\MediaService;
use App\Services\PageService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Renderless;
use Livewire\Component;

/**
 * Livewire component for creating and editing admin Pages.
 *
 * Handles auto-slug generation, validation, draft saving,
 * and publishing via PageService.
 */
final class PageForm extends Component
{
    use AuthorizesRequests;

    public string $title = '';

    public string $slug = '';

    public string $content = '';

    public string $status = 'draft';

    public bool $showMediaBrowser = false;

    /** @var array<int, array{id: int, url: string, alt: string}> */
    public array $mediaItems = [];

    #[Locked]
    public ?int $pageId = null;

    private PageService $pageService;

    private MediaService $mediaService;

    /**
     * Resolve services via Livewire boot — constructor injection is not supported by ComponentRegistry.
     */
    public function boot(PageService $pageService, MediaService $mediaService): void
    {
        $this->pageService   = $pageService;
        $this->mediaService  = $mediaService;
    }

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
            $this->authorize('update', Page::findOrFail($this->pageId));
        } else {
            $this->authorize('create', Page::class);
        }

        $this->persistPage();

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
            $this->authorize('update', Page::findOrFail($this->pageId));
        } else {
            $this->authorize('create', Page::class);
        }

        $page = $this->persistPage();

        $this->pageService->publish($page);

        session()->flash('success', 'Página publicada.');

        $this->redirect(route('admin.pages.index'), navigate: false);
    }

    /**
     * Accept a base64-encoded image from the TipTap editor, upload it through
     * MediaService, and return the public URL so the editor can embed it.
     *
     * @return array{url: string, alt: string}|array<never, never>
     */
    #[Renderless]
    public function uploadEditorImage(string $imageDataUrl): array
    {
        if (! preg_match('/^data:(?P<mime>image\/\w+);base64,(?P<data>.+)$/', $imageDataUrl, $matches)) {
            return [];
        }

        $mimeType  = $matches['mime'];
        $extension = match ($mimeType) {
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
            'image/gif'  => 'gif',
            default      => 'jpg',
        };

        $tmpPath = tempnam(sys_get_temp_dir(), 'editor_') . '.' . $extension;
        file_put_contents($tmpPath, base64_decode($matches['data']));

        $uploadedFile = new UploadedFile($tmpPath, 'editor-image.' . $extension, $mimeType, null, true);
        $media        = $this->mediaService->upload($uploadedFile, 'pages');

        @unlink($tmpPath);

        return [
            'url' => $this->mediaService->getUrl($media),
            'alt' => $media->alt_text ?? '',
        ];
    }

    /**
     * Load the latest images from the media library and show the browser panel.
     */
    public function loadMediaLibrary(): void
    {
        $this->mediaItems = Media::where('mime_type', 'like', 'image/%')
            ->latest()
            ->limit(40)
            ->get()
            ->map(fn (Media $m) => [
                'id'  => $m->id,
                'url' => $this->mediaService->getUrl($m),
                'alt' => $m->alt_text ?? '',
            ])
            ->toArray();

        $this->showMediaBrowser = true;
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
            'status'  => ['required', Rule::enum(ContentStatus::class)],
        ];
    }

    /**
     * Create or update the page record via PageService.
     */
    private function persistPage(): Page
    {
        $data = [
            'title'   => $this->title,
            'slug'    => $this->slug,
            'content' => $this->content,
            'status'  => $this->status,
        ];

        if ($this->pageId) {
            $page = Page::findOrFail($this->pageId);

            return $this->pageService->update($page, $data);
        }

        $page = $this->pageService->create($data);
        $this->pageId = $page->id;

        return $page;
    }
}
