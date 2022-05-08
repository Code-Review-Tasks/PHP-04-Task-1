<template class="fs-5">
    
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-2">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">URL Shortener</a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">                    
                    <router-link to="/" class="nav-link">Links</router-link>
                    <router-link to="/stats" class="nav-link">Stats</router-link>
                    <router-link to="/create" class="nav-link">Create</router-link>
                </div>
            </div>
        </div>
    </nav>

    

    <router-view></router-view>
</template>

<script>
import axios from "axios";

export default {
    setup() {},
};
</script>

<style scoped></style>
