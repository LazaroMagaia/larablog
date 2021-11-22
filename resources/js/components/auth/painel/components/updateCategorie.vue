<template>
    <div>
    <b-modal id="update" :title="'Editar a categoria '+id.item.name">
        <form @submit.prevent="">
            <h4 v-if="message">{{message.data}}</h4>
            <input type="text" v-model="form.name">
            <input type="hidden" >
        </form>
        <template v-slot:modal-footer={}>
            <button class="btn btn-primary" @click.prevent="editar(id.item.id)">Confirmar Edicao</button>
        </template>
    </b-modal>
    </div>
</template>
<script>
export default {
    props:['id'],
    data(){
        return{
            form:{
                name:''
            },
            message:'',
            search:''
        }
    },
    methods: {
        editar(id){
            axios.put("/api/auth/categories/"+id,this.form)
            .then((res)=>{this.message = "editado com sucesso"})
            .catch(error => this.errors = error.response.data.errors)
        }
    },
    created(){
        axios.get("/api/auth/categories/")
        .then(({data}) =>(this.form = data))
        .catch()
    }
}
</script>
