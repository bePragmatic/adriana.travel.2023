<template>
    <div class="row">
        <!-- right column -->
        <div class="col-md-8 col-sm-offset-2">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Post Form</h3>
                </div>


                <ul class="nav nav-tabs" id="myTab" role="tablist" v-cloak>
                    <li class="nav-item" v-for="post in data.translations">
                        <a class="nav-link" :id="post.id + '-tab'" data-toggle="tab" :href="'#' + post.id"
                           role="tab" aria-controls="post" aria-selected="false"
                        >{{ post.locale }}</a>
                    </li>
                </ul>

                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <div class="tab-content" id="myTabContent" v-cloak>
                        <div class="tab-pane fade active show" v-for="post in data.translations"
                             :id="post.id" role="tabpanel" :aria-labelledby="post.id + '-tab'">

                            <div class="row">
                                <div class="form-group">
                                    <div class="col col-sm-6">
                                        <label for="input_name" class="control-label">Post Title
                                            <em class="text-danger">*</em>
                                        </label>

                                        <input name="title" v-model="post.title"
                                               class="form-control name-input"
                                               :placeholder="'Post title' + post.locale"
                                               required>
                                    </div>

                                    <div class="col col-sm-6">
                                        <label for="slug" class="control-label">Slug (url)
                                            <em class="text-danger">*</em>
                                        </label>

                                        <input name="title"
                                               id="slug"
                                               class="form-control name-input"
                                               v-model="post.slug"
                                               :placeholder="'Post slug' + post.locale"
                                               required>
                                    </div>

                                    <div class="col col-sm-12 p-3 ">

                                        <label for="input_name" class="control-label">Post Content</label>

                                        <ckeditor :editor="editor" v-model="post.content"></ckeditor>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group">
                                    <div class="col col-sm-6">
                                        <label for="input_name" class="control-label">Meta Title</label>
                                        <input name="title" v-model="post.meta_title"
                                               class="form-control name-input"
                                               :placeholder="'Post meta ttle' + post.locale"
                                               required>
                                    </div>
                                    <div class="col col-sm-6">
                                        <label for="input_name" class="control-label">Meta keywords</label>
                                        <input name="title" v-model="post.meta_keywords"
                                               class="form-control name-input"
                                               :placeholder="'Post meta keywords' + post.locale"
                                               required>
                                    </div>

                                    <div class="col col-sm-12 mt-10">
                                        <label for="input_name" class="control-label">Meta description</label>
                                        <input name="title" v-model="post.meta_description"
                                               class="form-control name-input"
                                               :placeholder="'Post description' + post.locale"
                                               required>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="col col-sm-12 mt-10">
                            <div class="input-group">
                                <image-upload :data="data"></image-upload>

                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-info pull-right" name="submit" value="submit" @click="update">Submit
                        </button>
                        <button type="submit" class="btn btn-default pull-left cancel" name="cancel" value="cancel">
                            Cancel
                        </button>
                    </div>
                    <!-- /.box-footer -->
                </div>
                <!-- /.box -->
            </div>
            <!--/.col (right) -->
        </div>
        <!-- /.row -->

    </div>

</template>

<script>
    //ßimport CKEditor from '@ckeditor/ckeditor5-vue';
    import CKEditor from 'ckeditor4-vue';

   // import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

    export default {

        props: ['data'],

        mounted() {

        },

        components: {
            ckeditor: CKEditor.component
        },
        data() {
            return {
                img: '',
                lang: [],
                editor: ClassicEditor,
                data: this.data,
            };
        },

        methods: {
            update() {
                axios.put('/admin/posts/' + this.data.id,  this.data)
                    .then((response) => {
                        this.data = response.data
                    alert('Sejvan!')
                    });
            },

            sanitizeTitle: function(title) {
                var slug = "";
                // Change to lower case
                var titleLower = title.toLowerCase();
                // Letter "e"
                slug = titleLower.replace(/e|é|è|ẽ|ẻ|ẹ|ê|ế|ề|ễ|ể|ệ/gi, 'e');
                // Letter "a"
                slug = slug.replace(/a|á|à|ã|ả|ạ|ă|ắ|ằ|ẵ|ẳ|ặ|â|ấ|ầ|ẫ|ẩ|ậ/gi, 'a');
                // Letter "o"
                slug = slug.replace(/o|ó|ò|õ|ỏ|ọ|ô|ố|ồ|ỗ|ổ|ộ|ơ|ớ|ờ|ỡ|ở|ợ/gi, 'o');
                // Letter "u"
                slug = slug.replace(/u|ú|ù|ũ|ủ|ụ|ư|ứ|ừ|ữ|ử|ự/gi, 'u');
                // Letter "d"
                slug = slug.replace(/đ/gi, 'd');
                // Trim the last whitespace
                slug = slug.replace(/\s*$/g, '');
                // Change whitespace to "-"
                slug = slug.replace(/\s+/g, '-');

                return slug;
            },

            onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.data.img = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            // uploadImage(){
            //     axios.post('/image/store',{image: this.image}).then(response => {
            //         console.log(response);
            //     });
            // }

        }

    }
</script>
<style scoped>
    .col {
        margin-top:10px
    }
</style>
