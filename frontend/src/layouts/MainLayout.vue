<template>
	<div class="flex flex-col min-h-screen">
		<!-- Navbar -->
		<Navbar />

		<!-- Main content -->
		<main class="flex-1 container mx-auto px-4 py-6">
			<slot />
		</main>

		<!-- Footer -->
		<Footer />
	</div>
</template>

<script setup lang="ts">
	import Navbar from '@/components/Navbar.vue';
	import Footer from '@/components/Footer.vue';
</script>
