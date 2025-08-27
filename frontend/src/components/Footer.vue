<template>
	<footer class="bg-gray-800 text-gray-300 py-4 mt-10">
		<div class="max-w-7xl mx-auto px-4 text-ceter">
			<p>&copy; {{ year }} MEUT. Todos los derechos reservados</p>
		</div>
	</footer>
</template>

<script setup lang="ts">
	const year = new Date().getFullYear();
</script>
