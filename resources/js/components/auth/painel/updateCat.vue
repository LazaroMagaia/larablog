<template>
    <div>
        <Navbar></Navbar>
        <Noty/>
        <div class="categorie">
            <router-link to="/painel/categorie" class="btn btn-primary">Voltar</router-link>
            <h3>Editar a categoria {{form.name}}</h3>
            <form @submit.prevent="CatUpdate">
            <small v-if="msg">{{msg}}</small>
           <input type="text" v-model="form.name" class="form-control">
            <small class="text-danger" v-if="errors.name"><p>{{errors.name[0]}}</p></small>
            <input type="submit" value="Confirmar edicao" class="btn btn-primary">
        </form>
        </div>
    </div>
</template>
<script>
import Navbar from './components/Navbar.vue'
import Noty from './taiwindNoty.vue'
export default {
    data(){
        return{
            form:{
                name:''
            },
            cats:[],
            errors:[],
            msg:'',
        }
    },
    created(){
        let id = this.$route.params.id;
        axios.get("/api/auth/categories/"+id)
        .then(({data}) => (this.form = data))
        .catch()
    },
    methods:{
        CatUpdate(){
            let id = this.$route.params.id;
            axios.put("/api/auth/categories/"+id,this.form)
            .then(()=>{
                    this.$notify({
                    group: "top",
                    title: "Sucesso",
                    text: "Categoria editada com sucesso"
                    },4000)
                this.$router.push({name:'painel-categorie'})
            })
            .catch(()=>{
                this.$notify({
                group: "error",
                title: "Dica",
                text: "O campo Categoria deve ser preenchido"
                },4000)
            })
        }
    },
    components:{
        Navbar,
        Noty
    }
}
</script>
