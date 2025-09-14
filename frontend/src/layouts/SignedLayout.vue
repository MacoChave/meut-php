<script setup lang="ts">
	import Appbar from '@/components/Appbar.vue';
	import Footer from '@/components/Footer.vue';
	import Drawer from '../components/Drawer.vue';
</script>

<template>
	<v-layout class="w-dvw h-dvh">
		<!-- Appbar -->
		<Appbar />

		<!-- Navbar -->
		<Drawer />

		<!-- Main content -->
		<v-main class="flex flex-col">
			<div class="flex-1">
				<slot />
			</div>

			<!-- Footer -->
			<Footer class="flex-0" />
		</v-main>
	</v-layout>
</template>
