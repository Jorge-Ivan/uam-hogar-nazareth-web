import './bootstrap'
import 'quill/dist/quill.snow.css'

document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('#quill-editor')) {
        import('./editor/quill-editor.js').then(m => m.initPageEditor())
    }

    if (document.querySelector('#gallery-grid')) {
        import('./gallery-sort.js').then(m => m.initGallerySort())
    }
})

// Re-init after Livewire re-renders (e.g. after image upload)
document.addEventListener('livewire:navigated', () => {
    if (document.querySelector('#gallery-grid')) {
        import('./gallery-sort.js').then(m => m.initGallerySort())
    }
})

Livewire.hook('commit', ({ component, succeed }) => {
    succeed(() => {
        const grid = document.querySelector('#gallery-grid')
        if (grid && !grid._sortable) {
            import('./gallery-sort.js').then(m => m.initGallerySort())
        }
    })
})
