<template>
    <div class="linear-into">
        <p class="p">{{label}}</p>
        <slot></slot>
    </div>

</template>
<script setup>

defineProps({
    label:{
        type:String,
        required:true
    }
})

</script>
<style scoped lang="css">

</style>
