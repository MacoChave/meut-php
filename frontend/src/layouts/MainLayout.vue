<template>
	<div class="flex flex-col min-h-dvh">
		<!-- Navbar -->
		<Navbar class="bg-primary-950" />

		<!-- Main content -->
		<main class="flex-1 content-center container mx-auto">
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
