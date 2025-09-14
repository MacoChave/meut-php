<script setup lang="ts">
	import Footer from '@/components/Footer.vue';
	import Appbar from '../components/Appbar.vue';
</script>

<template>
	<v-layout class="min-h-dvh">
		<!-- Appbar -->
		<Appbar class="bg-primary-950" />

		<!-- Main content -->
		<v-main class="flex flex-col content-center container mx-auto">
			<div class="flex-1">
				<slot />
			</div>

			<!-- Footer -->
			<Footer class="flex-0" />
		</v-main>
	</v-layout>
</template>
