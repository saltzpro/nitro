<script lang="ts" setup>

</script>

<template>
    <div class="card-container border shadow-sm rounded p-4">
        <slot></slot>
    </div>
</template>

<style lang="scss">
    .card-container {
        background-color: $white1;
        
        .card-title {
            @include poppins-font(20px, normal, 700, $black3);
        }
    }
</style>
