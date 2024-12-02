<template>
    <PageBase title="Lista delle birre">
        <template v-slot:page-icon-end>
            <IconActioTable icon="mdi-reload" alt="Reload" color="#ffffff" @click="reload"></IconActioTable>
            <IconActioTable icon="mdi-filter" alt="Filtri di ricerca" color="#ffffff" @click="openFilter"></IconActioTable>
        </template>
        <template v-slot:content>
            <div style="display:flex;flex-direction: column;border-bottom: 2px solid #eeeeee;marging-bottom:10px" v-if="isFilter">
                <FormInlineBase label="Name">
                    <template v-slot:default>
                        <v-text-field
                            type="text"
                            variant="outlined"
                            v-model="filter.by_name"
                            clearable
                        >
                        </v-text-field>
                    </template>
                </FormInlineBase>
                <FormInlineBase label="Type">
                    <template v-slot:default>
                        <v-select
                            :items="selectType"
                            variant="outlined"
                            v-model="filter.by_type"
                            clearable
                        ></v-select>
                    </template>
                </FormInlineBase>
                <BtnActionDialog :loading="loading" text="Filtra" color="accent" @click="filterResult"></BtnActionDialog>
            </div>
            <Table
                :items="items"
                :headers="headers"
                :loading="loading">
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
import FormInlineBase from "../common/FormInlineBase.vue";
import BtnActionDialog from "../common/BtnActionDialog.vue";

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

const selectType = ref([
    {title:"micro",value: "micro"},
    {title:"nano", value:"nano"},
    {title:"regional", value:"regional"},
    {title:"brewpub", value:"brewpub"},
    {title:"large", value:"large"},
    {title:"planning", value:"planning"},
    {title:"bar",value: "bar"},
    {title:"contract", value:"contract"},
    {title:"proprietor", value:"proprietor"},
    {title:"closed", value:"closed"},
])

const filter = ref({
    by_type:null,
    by_name:null
})

const loading = ref(false)
const options = ref({
    totalItems: 0,
    sortBy: {
        orderBy: 'name',
        order:'desc'
    },
    page:1,
})
const isFilter = ref(false)
const search = ref(null)
const openFilter = () => {
    isFilter.value = !isFilter.value
}
const filterResult = () => {
    let queryString = "";
    for(let k of Object.keys(filter.value)){
        if(filter.value[k] !== null)
            queryString += k+"="+filter.value[k]
    }
    list(queryString)

}

const reload = () => {
    filter.value = {
        by_type:null,
        by_name:null
    }
    isFilter.value = false
    list()
}


const list =(queryString) => {
    loading.value = true
    let path = 'list';
    if(queryString !== undefined)
        path +='?'+queryString
    api(path,'GET').then(r => {
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
