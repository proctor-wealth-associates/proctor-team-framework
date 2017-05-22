<template>
    <div class="ui fluid file input action">
        <input type="text" @click="triggerFileClick" v-model="fileNames" readonly>
        <input type="file" @change="updateTextInput" :name="name" autocomplete="off" :multiple="isMultiple">
        <div class="ui basic button" @click="triggerFileClick">
            <slot>Select...</slot>
        </div>
    </div>
</template>

<script>
export default {
    props: ['name', 'multiple'],

    data() {
        return {
            fileNames: ''
        }
    },

    computed: {
        isMultiple() {
            return typeof this.multiple !== 'undefined';
        }
    },

    methods: {
        triggerFileClick(event) {
            $(event.target).parent().find('input:file').click();
        },
        updateTextInput(event) {
            let fileNames = '';
            let selectedFiles = event.target.files;


            for (var i = 0; i < selectedFiles.length; i++) {
                fileNames += selectedFiles[i].name + ', ';
            }

            fileNames = fileNames.replace(/,\s*$/, '');

            this.fileNames = fileNames;
        }
    }
}
</script>
