<template>
	<nav class="bg-blue-600 text-white shadow-md">
		<div
			class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
			<!-- Brand -->
			<router-link to="/" class="text-xl font-bold">MEUT</router-link>

			<!-- Links -->
			<div class="space-x-4">
				<router-link to="/" class="hover:text-gray-200 transition"
					>home</router-link
				>
				<router-link to="/Login" class="hover:text-gray-200 transition"
					>Login</router-link
				>
			</div>
		</div>
	</nav>
</template>

<script setup lang="ts"></script>
