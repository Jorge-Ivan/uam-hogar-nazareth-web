import Quill from 'quill'

/**
 * Get the Livewire component instance for the current page.
 * Works with Livewire 3's JS API.
 */
function getWire() {
    const el = document.querySelector('[wire\\:id]')
    return el ? window.Livewire?.find(el.getAttribute('wire:id')) : null
}

/**
 * Initialize the Quill rich-text editor on the page form.
 * Called once from app.js on DOMContentLoaded.
 */
export function initPageEditor() {
    const container = document.querySelector('#quill-editor')
    if (!container) return

    const quill = new Quill('#quill-editor', {
        theme: 'snow',
        modules: {
            toolbar: {
                container: [
                    ['bold', 'italic'],
                    [{ header: 2 }, { header: 3 }],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    ['link', 'image'],
                ],
                handlers: {
                    image: () => {
                        const input = document.createElement('input')
                        input.type = 'file'
                        input.accept = 'image/*'
                        input.click()
                        input.onchange = () => {
                            const file = input.files[0]
                            if (!file) return
                            const reader = new FileReader()
                            reader.onload = async (e) => {
                                const result = await getWire()?.uploadEditorImage(e.target.result)
                                if (result?.url) {
                                    const range = quill.getSelection(true)
                                    quill.insertEmbed(range.index, 'image', result.url, 'user')
                                    quill.setSelection(range.index + 1)
                                }
                            }
                            reader.readAsDataURL(file)
                        }
                    },
                },
            },
        },
    })

    // Load initial content stored in data-content attribute
    const initialHtml = container.dataset.content || ''
    if (initialHtml) {
        const delta = quill.clipboard.convert({ html: initialHtml })
        quill.setContents(delta, 'silent')
    }

    // Sync to Livewire on every user change
    quill.on('text-change', (delta, oldDelta, source) => {
        if (source === 'silent') return
        // Quill double-encodes & from pasted plain text (& → &amp;); decode one level for entities
        const html = quill.getSemanticHTML()
            .replace(/&amp;([a-zA-Z]+;|#[0-9]+;|#x[0-9a-fA-F]+;)/g, '&$1')
        getWire()?.set('content', html)
    })

    // Expose globally for Livewire-rendered media browser thumbnails
    window.insertFromLibrary = (url, alt) => {
        const range = quill.getSelection(true)
        quill.insertEmbed(range.index, 'image', url, 'user')
        quill.setSelection(range.index + 1)
        getWire()?.set('showMediaBrowser', false)
    }
}
