<template>
  <v-btn
      :color="color"
      variant="elevated"
      @click="action"
      :loading="load">
    {{text}}
  </v-btn>

</template>
<script setup>
import {ref, watch} from "vue";

const props = defineProps({
  text:{
    type:String,
    required:true
  },
  loading:{
    type:Boolean,
    required:true
  },
  color:{
    type: [String,null],
    default:"primary"
  }
})
const load = ref(false)

watch(()=> props.loading, (value) =>{
  load.value = value
})

const emits = defineEmits(['click'])

const action = () => {
  emits('click')
}

</script>
<style scoped lang="css">

</style>
