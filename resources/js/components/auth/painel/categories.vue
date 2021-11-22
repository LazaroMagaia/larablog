<template>
    <div>
        <Navbar/>
        <NotyT/>
        <div class="categorie">
            <form @submit.prevent="create">
                  <input type="text" v-model="form.name" class="form-control">
                  <button type="submit" class="btn btn-primary">Nova categoria</button>
            </form>
            <div class="categorie-list">
            <b-table styck-header striped hover :items="categories" :fields="fields">
            <template v-slot:cell(action)="data">
               <!-- <b-button class="btn btn-warning" v-b-modal.update
                    @click="editarOpen(data)">Editar</b-button>-->
                <router-link :to="{name:'painel-categorie-update',params:{id:data.item.id}}"
                class="btn btn-primary">
                    Editar</router-link>
                <b-button class="btn btn-danger" @click="removerOpen(data.item.id)">Removar</b-button>
            </template>
            </b-table>
            </div>
        </div>
    </div>
</template>
<script>
import Navbar from './components/Navbar.vue'
import NotyT from './taiwindNoty.vue'
export default {
    data(){
        return{
            fields:[
                {key:'id', label:'id'},
                {key:'name' , label:"Categoria"},
                {key:"action", label:'Acoes'}
                ],
            form:{
                name:'',
            },
            errors:{},
            categories:[],
            id:'',
        }
    },
    created(){
        this.allCategories();
    },
    components:{
        Navbar,
        NotyT
    },
    methods:{
        create(){
            if(!User.loggedIn())
            {
                this.$router.push({name: 'login'})
            }
            axios.post("/api/auth/categories",this.form)
            .then(()=>{ this.$notify({
                group: "top",
                title: "Success",
                text: "Categoria criada com sucesso"
                },4000);
                this.allCategories()
             }).catch(()=>{ this.$notify({
                group: "error",
                title: "Dica",
                text: "O campo Categoria deve ser preenchido"
                },4000);
                this.allCategories()
             })
        },
        allCategories(){
            axios.get('/api/auth/categories')
            .then(({data})=>(this.categories = data))
            .catch()
        },
        editarOpen(id){
            this.id = id;
        },
        removerOpen(id){
            axios.delete('/api/auth/categories/'+id)
            .then(()=>{
                    this.$notify({
                    group: "top",
                    title: "Success",
                    text: "Categoria removida com sucesso"
                    },4000);
                  this.categories = this.categories.filter(categories=>{
                    return categories.id != id;
                  })
                }).catch(()=>{
                  this.$router.push({name:'painel'})
                })
        }
    },
}
</script>
