<template>
	<div
		class="w-full bg-primary-950 text-gray-50 text-center p-2 rounded-lg shadow-md">
		<h2 class="text-xl font-semibold mb-4">{{ title }}</h2>
		<p v-if="subtitle" class="text-lg mb-4">{{ subtitle }}</p>
	</div>
	<!-- Image -->
	<div class="w-full flex justify-center">
		<picture>
			<source v-if="webp" :srcset="webp" type="image/webp" />
			<img
				v-if="webp"
				:src="webp"
				:alt="`Image for ${title}`"
				loading="lazy"
				class="w-full max-w-md rounded-lg shadow-md" />
		</picture>
	</div>
</template>

<script setup lang="ts">
	defineProps<{
		title: string;
		subtitle?: string;
		webp?: string;
		jpg?: string;
	}>();
</script>
