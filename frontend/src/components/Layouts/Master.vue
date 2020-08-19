<template>
    <v-app id="inspire">
        <!-- side bar enabled -->
    <div >
        <sidebar/>
        <!-- top navigation -->
        <topnavigation/>
    </div>
        <!-- body of the page -->
        <v-content>
            <v-responsive>
                <div class="container-fluid my-3 p-0">
                    <!-- <breadcrumbs/> -->
                    <router-view :key="$route.path"></router-view>
                </div>
            </v-responsive>
        </v-content>
    </v-app>
</template>

<script>
import sidebar from '@/components/NavigationBars/sidebar';
import topnavigation from '@/components/NavigationBars/top-navigation';

  export default {
    props: {
      source: String,
    },
    components: {
        sidebar,
        topnavigation,
    },
    data: () => ({
      
    }),
    computed:  {
        
    },
    created() {
    }
    
  }
</script>