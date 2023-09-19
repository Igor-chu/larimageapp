<template>
    <div class="w-25">
        <input v-model="title" type="text" class="form-control mb-3" placeholder="title">
<!--        <textarea v-model="content" name="content" class="form-control mb-3" placeholder="content"></textarea>-->
        <div ref="dropzone" class="btn d-block p-5 bg-dark text-center text-light mb-3">
            Upload
        </div>

<!--        <input v-model="content" type="text" class="form-control mb-3" placeholder="content">-->


        <div class="mb-3">
            <QuillEditor
                v-model="content"
                debug="true"
                theme="snow"
                toolbar="full"
                getCo

                useCustomImageHandler
                @image-added="handleImageAdded"
            />
        </div>

        <input @click.prevent="store" type="submit" class="btn btn-primary" value="add">

        <div class="mt-5">
            <div v-if="post">
                <h4>{{post.title}}</h4>

                <div v-for="image in post.images">
                    <img width="100" :src="image.preview_url" class="mb-3">
                    <img width="300" :src="image.url" class="mb-3">
                </div>

                <p>{{post.content}}</p>
            </div>
        </div>
    </div>
</template>

<script>
import Dropzone from 'dropzone';
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';


    export default {
        name: "Index",

        data(){
            return {
                dropzone: null,
                title: null,
                post: null,
                content: null
            }
        },

        components: {
            QuillEditor
        },

        mounted() {
            this.dropzone = new Dropzone(this.$refs.dropzone, {
                url: "/api/posts",
                autoProcessQueue: false,
                addRemoveLinks: true
            })

            this.getPost()
        },

        methods: {
            store() {
                const data = new FormData()
                const files = this.dropzone.getAcceptedFiles()
                files.forEach(file => {
                    data.append('images[]', file)
                    this.dropzone.removeFile(file)
                })

                data.append('title', this.title)
                this.title = ''
                data.append('content', this.content)
                this.content = ''

                axios.post('/api/posts', data)
                    .then(res => {
                        this.getPost()
                    })
            },

            getPost() {
                axios.get('/api/posts')
                    .then(res => {
                        this.post = res.data.data
                        console.log(res.data.data);
                    })
            },

            handleImageAdded(file, Editor, cursorLocation, resetUploader) {
                console.log(file)
            }
        }
    }

</script>
