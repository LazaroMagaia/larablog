<template>
    <div class="create">
        <Navbar/>
        <Noty/>
        <router-link to="/painel" class="criar btn btn-primary">Voltar</router-link>
        <div class="create-form text-center">
            <form @submit.prevent="update">
             <div class="col-md-12" v-show="!imageshow">
                    <img :src="'/'+form.image" style="height:350px; width:100%; object-fit:cover;">
                </div><!--col-md-12-->
                <div class="col-md-12" v-show="imageshow">
                    <img :src="form.image" style="height:350px; width:100%; object-fit:cover;">
                </div><!--col-md-12-->

                <div class="image-form">
                    <label for="imageInput"><i class="write-icon fas fa-plus"></i></label>
                    <input type="file" id="imageInput" @change="onFileSelected">
                    <b-form-group>
                        <label for="categorie">Categoria</label>
                        <select v-model="form.categorie" id="categorie">
                        <option v-for="cat in categories" :key="cat.id">
                            {{ cat.name }}
                        </option>
                        </select>
                    </b-form-group>
                </div>

                <b-form-group>
                <input type="text" v-model="form.title" class="title" placeholder="Titlo">
                </b-form-group>

                <b-form-group>
                    <editor v-model="form.description"
                        api-key="mxn0ww1hngu4x5rout14iqkeoqkeplxar1yrz6yni0fwtaaq"
                        :init="{
                            height: 500,
                            menubar: false,
                            plugins: [
                            'advlist autolink lists link image charmap print preview anchor',
                            'searchreplace visualblocks code fullscreen',
                            'insertdatetime media table paste code help wordcount'
                            ],
                            toolbar:
                            'undo redo | formatselect | bold italic backcolor | \
                            alignleft aligncenter alignright alignjustify | \
                            bullist numlist outdent indent | removeformat | help'
                        }"
                        />
                    <small class="text-danger" v-if="errors.description">
                    {{errors.description[0]}} </small>
                </b-form-group>
                <button type="submit" class="btn btn-primary p-3">Publicar</button>
            </form>
        </div>
    </div>
</template>
<script>
import Navbar from './components/Navbar.vue'
import editor from '@tinymce/tinymce-vue'
import Noty from './taiwindNoty.vue'
const authorName = localStorage.getItem('user');
export default {
    data(){
        return{
            categories:[],
            form:{
                title:'',
                description:'',
                slug:'',
                image:'',
                newimage:'',
                categorie: '',
                author:'',
            },
            errors:{},
            imageshow: false,
        }
    },
    created(){
        if(!User.loggedIn())
        {
            this.$router.push({name: 'login'})
        }
        this.allblogs();
        this.allcategories();
    },
    components:{
        Navbar,
        editor,
        Noty
    },
    methods:{
        allblogs(){
            let id = this.$route.params.id;
            axios.get('/api/auth/blog/'+id)
            .then(({data})=>(this.form = data))
            .catch()
        },
        allcategories(){
           axios.get('/api/auth/categories')
            .then(({data})=>(this.categories = data))
            .catch()
        },
            onFileSelected(event){
            let file = event.target.files[0];
            if(file.size > 1048770){
                    this.$notify({
                    group: "error",
                    title: "Dica",
                    text: "imagem invalida, TENTE UMA MENOR DE 1MB"
                    },4000)
            }else
            {
                let reader = new FileReader();
                reader.onload = event =>{
                   this.form.image = event.target.result;
                   this.form.newimage = this.form.image;
                };
                this.imageshow = true;
                reader.readAsDataURL(file);
            }
        },
        update(){
            let id = this.$route.params.id;
            this.form.author = authorName;
            this.form.slug = this.form.title;
            axios.put('/api/auth/blog/'+id,this.form)
            .then(()=>{
                    this.$notify({
                    group: "top",
                    title: "Sucesso",
                    text: "Artigo editado com sucesso"
                    },4000)
                this.$router.push({name:'painel'})
            }).catch(error => this.errors = error.response.data.errors)
        }
    }
}
</script>
