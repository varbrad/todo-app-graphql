<template>
  <div>
    <app-nav/>
    <nuxt/>
  </div>
</template>

<script>
import AppNav from '@/components/AppNav';

export default {
  middleware: 'try-auth',
  components: {
    AppNav
  }
};
</script>
