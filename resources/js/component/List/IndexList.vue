<template>
<PageBase title="Lista delle birre">
    <template v-slot:page-icon-end>
        <IconActioTable icon="mdi-reload" alt="Reload" color="primary" @click="reload"></IconActioTable>
    </template>
        <template v-slot:content>
            <Table
                :items="items"
                :headers="headers"
                :loading="loading"
                @load="loadList"
            </Table>
        </template>
</PageBase>
</template>

<script setup>

import {onBeforeMount, ref} from "vue";
import TableServer from "../common/TableServer.vue";
import PageBase from "../common/PageBase.vue";
import {api} from "../../api/index.js";
import IconActioTable from "../common/IconActioTable.vue";
import Table from "../common/Table.vue";

const items = ref([]);
const headers = ref([
    {title:'Name',key:'name',align:'left'},
    {title:'Type',key:'brewery_type',align:'left'},
    {title:'City',key:'city',align:'left'},
    {title:'Province',key:'state_province',align:'left'},
    {title:'Postal Code',key:'postal_code',align:'left'},
    {title:'Country',key:'country',align:'left'},
    {title:'Phone',key:'phone',align:'left'},
    {title:'Website',key:'website_url',align:'left'},
    {title:'Website',key:'website_url',align:'left'},
    {title:'State',key:'state',align:'left'},
    {title:'Street',key:'street',align:'left'},
    ]);

const loading = ref(false)
const options = ref({
    totalItems: 0,
    sortBy: {
        orderBy: 'name',
        order:'desc'
    },
    page:1,
})
const search = ref(null)

const reload = () => {
    list()
}


const list =() => {
    api('list','GET').then(r => {
        items.value = r
        loading.value = false
    }).catch(() => {
        loading.value = false
    })
}
onBeforeMount(() =>{
    list();
})

</script>
<style scoped lang="css">
</style>
