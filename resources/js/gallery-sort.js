import Sortable from 'sortablejs'

function getWire() {
    const el = document.querySelector('[wire\\:id]')
    return el ? window.Livewire?.find(el.getAttribute('wire:id')) : null
}

export function initGallerySort() {
    const grid = document.querySelector('#gallery-grid')
    if (!grid) return

    // Destroy existing instance to avoid duplicates after re-renders
    if (grid._sortable) {
        grid._sortable.destroy()
    }

    grid._sortable = new Sortable(grid, {
        animation: 150,
        ghostClass: 'opacity-40',
        handle: '[data-drag-handle]',
        onEnd() {
            const orderedIds = [...grid.querySelectorAll('[data-id]')]
                .map(el => parseInt(el.dataset.id))

            getWire()?.reorder(orderedIds)
        },
    })
}
