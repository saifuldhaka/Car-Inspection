<template>
    <v-navigation-drawer v-model="drawer" :mini-variant="mini" app permanent color="primary" fluid dark>
        <div class="mt-5">
            <p class="pt-2 px-5 text-center"><img src="../../assets/icon-inspection.png" class="logo"></p>
        </div>
        <hr class="light-blue lighten-1">

        <v-list-item style="padding-left: 15px;" to='/booking-list'  >
            <v-list-item-action>
                <v-icon :size="size">fas fa-list</v-icon>
            </v-list-item-action>
            <v-list-item-content>
                <v-list-item-title>Booking List</v-list-item-title>
            </v-list-item-content>
        </v-list-item>


        <v-list-item style="padding-left: 15px;" to='/create-booking'  >
            <v-list-item-action>
                <v-icon :size="size">fas fa-list</v-icon>
            </v-list-item-action>
            <v-list-item-content>
                <v-list-item-title>Create Booking</v-list-item-title>
            </v-list-item-content>
        </v-list-item>

        <v-divider></v-divider>


        <v-row>
            <v-col>
                <div class="text-center m-auto">
                    <v-app-bar-nav-icon @click="navClick()">
                        <v-btn fab small color="light-blue lighten-5" v-if="sidebarMenu" dark class="elevation-0" >
                            <v-icon color="primary" large elevation="selected">mdi-chevron-right</v-icon>
                        </v-btn>
                        <v-btn fab small color="light-blue lighten-5" v-else="sidebarMenu" dark class="elevation-0" >
                            <v-icon color="primary" large>mdi-chevron-left</v-icon>
                        </v-btn>
                    </v-app-bar-nav-icon>
                </div>
            </v-col>
        </v-row>
    </v-navigation-drawer>
</template>
<style scoped>
    .v-list-item__title {
        color: #000;
    }

    .v-list-item__icon,
    .v-icon {
        color: #000;
    }

    .v-application .primary {
        background-color: #fecf3d  !important;
    }

</style>

<script>
    export default {
        data: () => ({
            sidebarMenu : true,
            drawer: true,
            mini: false,
            size: 'small',
            tooltipdisable: true,
            iconColor: '#000',
        }),
        mounted() {
            this.$root.$on('toggle', () => {
                this.mini = !this.mini;
                if (this.mini == true) {
                    this.tooltipdisable = false;
                } else {
                    this.tooltipdisable = true;
                }
            })
        },
        methods: {
            navClick: function() {
                this.sidebarMenu = !this.sidebarMenu;
                this.$root.$emit('toggle');
            }
        }
    };

</script>
