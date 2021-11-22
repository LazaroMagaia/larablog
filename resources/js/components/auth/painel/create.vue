<template>
    <div class="create">
        <Navbar/>
        <Noty/>
        <router-link to="/painel" class="criar btn btn-primary">Voltar</router-link>
        <div class="create-form text-center">
            <form @submit.prevent="create">
                <div class="col-md-12">
                    <img :src="form.image" style="height:350px; width:100%; object-fit:cover;">
                </div><!--col-md-6-->
                <div class="image-form">
                    <label for="imageInput"><i class="write-icon fas fa-plus"></i></label>
                    <input type="file" id="imageInput" @change="onFileSelected">
                    <b-form-group>
                        <label for="categorie" style="cursor:pointer;">Categoria</label>
                        <select v-model="form.categorie" id="categorie">
                        <option v-for="cat in categories" :key="cat.id">
                            {{ cat.name }}
                        </option>
                        </select>
                        <small class="text-danger" v-if="errors.categorie">
                        {{errors.categorie[0]}}</small>
                    </b-form-group>
                </div>

                <b-form-group>
                <input type="text" v-model="form.title" class="title" placeholder="Titlo">
                    <small class="text-danger" v-if="errors.title">
                    {{errors.title[0]}}</small>
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
                categorie: '',
                author:''
            },
            errors:{},
        }
    },
    created(){
        this.allcategories()
        if(!User.loggedIn())
        {
            this.$router.push({name: 'login'})
        }
    },
    components:{
        Navbar,
        editor,
        Noty
    },
    methods:{
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
                    this.form.image = event.target.result
                    console.log(event.target.result)
                };
                reader.readAsDataURL(file);
            }
        },
        create(){
            this.form.slug = this.form.title;
            this.form.author = authorName;
            axios.post("/api/auth/blog",this.form)
            .then(res=>{this.$notify({
                group: "top",title: "Sucesso",text: "Artigo criado com sucesso"},5000)
                })
            .catch(error => this.errors = error.response.data.errors)
        }
    }
}
</script>
