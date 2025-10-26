<script lang="ts" setup>

</script>

<template>
    <div class="user-event-main-container">
        <card-header></card-header>

        <div class="main-container d-flex align-items-center justify-content-center w-100">
            <slot></slot>
        </div>
    </div>
</template>

<style lang="scss">
    .user-event-main-container {
        height: 100vh;
        overflow: hidden auto;
    }
</style>
