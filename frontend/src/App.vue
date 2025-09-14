<script setup lang="ts">
	import { useRoute } from 'vue-router';
	import MainLayout from './layouts/MainLayout.vue';
	import SignedLayout from './layouts/SignedLayout.vue';

	const route = useRoute();

	const layouts: Record<string, any> = {
		MainLayout,
		SignedLayout,
	};
</script>

<template>
	<component :is="layouts[route.meta.layout] || 'div'">
		<router-view />
	</component>
</template>
