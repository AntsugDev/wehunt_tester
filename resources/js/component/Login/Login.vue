<template>
    <PageBase title="Login" :border="true" :container="true" :center="true">
        <template v-slot:content>
            <v-form ref="formLogin" v-model="valid">
                <v-text-field
                    :disabled="loading" color="primary" label="email" name="email"
                    prepend-icon="mdi-at"
                    v-model="form.email"
                    :rules="[rulesRequired,rulesEmail]"
                    type="email"
                ></v-text-field>
                <v-text-field
                    :disabled="loading" color="primary" id="password" label="Password"
                    name="password" prepend-icon="mdi-lock"
                    v-model="form.password"
                    :rules="[rulesRequired]"
                    type="password"
                ></v-text-field>
            </v-form>
            <v-btn
                variant="elevated"
                color="success"
                @click="login"
                text="Accedi"
                :loading="loading"
            ></v-btn>
        </template>
    </PageBase>



</template>
<script setup>
import {rulesEmail, rulesRequired} from "../../utils/rules.js";
import {onMounted, ref} from "vue";
import Title from "../common/Title.vue";
import {api} from "../../api/index.js";
import {useRoute, useRouter} from "vue-router";
import {useStore} from "vuex";
import {LoadRelationship} from "../../utils/LoadRelationship.js";
import PageBase from "../common/PageBase.vue";
const formLogin = ref(null)
const valid = ref(false)
const form = ref({
    email: "",
    password: ""
})
const loading = ref(false)
const router = useRouter();
const route = useRoute();
const store = useStore()
const login = () => {
    loading.value = true
    formLogin.value.validate().then(r => {
        if(r.valid){
            api('auth','POST',{
                email:form.value.email,
                password: form.value.password
            },null,false,LoadRelationship.user).then(ro => {
                store.commit('user/update', ro)
                // getMenu();
                router.push({name:'Home'})
                loading.value = false
            }).catch(e => {
                loading.value = false
            })
        }else
            loading.value = false

    })

}

const logoutRoot = async () => {
    await api('at/logout','GET')
    store.commit('user/clear')
}

onMounted(() => {

    if(route.query.error !== undefined){
        store.commit('snackbar/update',{
            show:true,
            color:'error',
            text:atob(route.query.error),
            button:true,
            preicon: "mdi-alert-outline"
        })
    }

    if(route.query.logout !== undefined){
        if(route.query.error === undefined)
            store.commit('snackbar/update',{
                show:true,
                color:'success',
                text:"Logout effettuato",
            })
        logoutRoot();
    }

})


</script>
<style scoped lang="css">

</style>
