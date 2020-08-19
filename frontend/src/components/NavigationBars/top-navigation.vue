<template>
    <nav >
        <v-app-bar app light>
            <!--
            <v-app-bar-nav-icon @click="navClick()">
                <v-icon v-if ="sidebarMenu" color="orange">mdi-view-comfy</v-icon>
                <v-icon v-else ="sidebarMenu" color="primary">mdi-view-dashboard</v-icon>
            </v-app-bar-nav-icon>
-->
            <v-app-bar-nav-icon @click="navClick()">
                <v-btn fab small color="light-blue lighten-5" v-if="sidebarMenu" dark class="elevation-0" >
                    <v-icon color="primary" large elevation="selected">mdi-chevron-right</v-icon>
                </v-btn>
                <v-btn fab small color="light-blue lighten-5" v-else="sidebarMenu" dark class="elevation-0" >
                    <v-icon color="primary" large>mdi-chevron-left</v-icon>
                </v-btn>
            </v-app-bar-nav-icon>
            <!--            <v-toolbar-title>Heading</v-toolbar-title>-->
            <v-spacer></v-spacer>
         

            <!-- end notifications -->
            <v-menu :close-on-content-click="true" :nudge-width="100" offset-y padding-right="10px;">

            </v-menu>

        </v-app-bar>
    </nav>
</template>
<style scoped>
    .icon-pad {
        padding-bottom: 6px;
    }
    .theme--light.v-sheet {
        background-color: #fecf3d  !important;
    }
</style>

<script>
    export default {
        data: () => ({
            sidebarMenu: false,
        }),
        methods: {
            navClick: function() {
                this.sidebarMenu = !this.sidebarMenu;
                this.$root.$emit('toggle');
            }
        }

    };

</script>
