import './bootstrap'
import 'quill/dist/quill.snow.css'

document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('#quill-editor')) {
        import('./editor/quill-editor.js').then(m => m.initPageEditor())
    }
})
