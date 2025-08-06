<template>
    <div>
        <div :id="'toolbar-container-' + unique_ref">
            <span class="ql-formats">
                <select class="ql-size"></select>
            </span>
            <span class="ql-formats">
                <select class="ql-color"></select>
                <select class="ql-background"></select>
            </span>
            <span class="ql-formats">
                <button class="ql-bold"></button>
                <button class="ql-italic"></button>
                <button class="ql-underline"></button>
                <button class="ql-strike"></button>
            </span>
            <span class="ql-formats">
                <select class="ql-align"></select>
                <button class="ql-list" value="ordered"></button>
                <button class="ql-list" value="bullet"></button>
            </span>
            <span class="ql-formats">
                <button class="ql-link"></button>
            </span>
        </div>
        <div :ref="unique_ref" class="text-editor"></div>
    </div>
</template>

<script>
import Quill from 'quill';
import "quill/dist/quill.snow.css";
import "quill/dist/quill.core.css";

export default {
    props: ['unique_ref', 'placeholder', 'initial_content'],
    mounted() {
        this.initializeEditor();
    },
    destroyed() {
        if (this.editor) {
            this.editor.destroy();
        }
    },
    data() {
        return {
            editor: null,
            content: ''
        }
    },
    watch: {
        content() {
            this.$emit('text_changed', this.content);
        },
    },
    methods: {
        initializeEditor() {
            const toolbarId = '#toolbar-container-' + this.unique_ref;
            
            this.editor = new Quill(this.$refs[this.unique_ref], {
                theme: 'snow',
                debug: false,
                modules: {
                    toolbar: {
                        container: toolbarId,
                        handlers: {
                            // Puedes agregar handlers personalizados aquí si los necesitas
                        }
                    }
                },
                placeholder: this.placeholder
            });

            if (this.initial_content) {
                this.editor.root.innerHTML = this.initial_content;
            }

            this.editor.on('text-change', this.handleTextEditorContentChange);
        },
        handleTextEditorContentChange() {
            this.content = this.editor.root.innerHTML;
        },
    },
}
</script>

<style scoped>
.text-editor {
    min-height: 100px; /* Ajusta el tamaño mínimo según tus necesidades */
    max-height: 150px; /* Limita la altura máxima */
    overflow-y: auto; /* Muestra el scroll si el contenido excede el máximo */
    font-size: 16px;
    border: 1px solid #ccc;
    border-bottom-left-radius: 4px;
    border-bottom-right-radius: 4px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    padding: 1px;
}
</style>