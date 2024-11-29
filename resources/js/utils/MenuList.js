import IndexList from "../component/List/IndexList.vue";

export const MenuList = (isRoot) => {

    return [
        {
            text:'Lista Birre',
            icon: 'mdi-glass-mug-variant',
            routeName: 'IndexList',
            children:[]
        },

    ]

}
