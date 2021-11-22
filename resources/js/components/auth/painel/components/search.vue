<template>
    <div>
        <form class="form form-inline" @submit.prevent="search">
            <input type="text" class="form-control mt-3 mb-3" v-model="filter" placeholder="Procuro por...">
            <button class="btn btn-primary">Pesquisar</button>
        </form>
    </div>
</template>
<script>
export default {
    data(){
        return{
            filter:''
        }
    },
    methods:{
        search(){
            this.$emit('search',this.filter)
        }
    }
}
</script>
