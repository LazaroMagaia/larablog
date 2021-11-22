<template>
    <div>
    <b-modal id="delete" :title="'Editar a categoria '+id.item.name">

        <template v-slot:modal-footer={}>
            <button class="btn btn-primary" @click="editar(id.item.id)">Confirmar Edicao</button>
        </template>
    </b-modal>
    </div>
</template>
<script>
export default {
    created(){
        this.allCategories();
    },
    props:['id'],
    data(){
        return{

        }
    },
    methods: {
        editar(id){
            axios.delete("/api/auth/categories/"+id)
            .then(()=>{
                  this.posts = this.posts.filter(post=>{
                    return post.id != id;
                  })
                })
            .catch(error => this.errors = error.response.data.errors)
        },
        allCategories(){
            axios.get('/api/auth/categories')
            .then(({data})=>(this.categories = data))
        }
    },
}
</script>
