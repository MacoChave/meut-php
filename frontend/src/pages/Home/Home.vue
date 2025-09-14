<script setup lang="ts">
	import CourseAssignImg from '@/assets/webp/CourseAssignment.webp';
	import DocsAuthImg from '@/assets/webp/DocsAuth.webp';
	import ThesisPrintImg from '@/assets/webp/ThesisPrintAuth.webp';
	import StationInfo from './components/StationInfo.vue';
</script>

<template>
	<div
		class="flex flex-col items-center justify-items-start mt-8 gap-8 h-full bg-gray-50">
		<h1 class="text-5xl">Unidad de tesis</h1>
		<p class="text-3xl">Flujo de procesos</p>

		<!-- Station info : Recepción de punto de tesis -->
		<StationInfo title="Recepción de punto de tesis" :webp="DocsAuthImg" />
		<!-- Station info : Curso I -->
		<StationInfo
			title="Curso I"
			subtitle="Inducción a la planeación científica"
			:webp="CourseAssignImg" />
		<!-- Station info : Curso II  -->
		<StationInfo
			title="Curso II"
			subtitle="Elaboración y presentación de tesis"
			:webp="CourseAssignImg" />
		<!-- Station info : Comisión y estilo -->
		<StationInfo title="Comisión y estilo" :webp="DocsAuthImg" />
		<!-- Station info : Previos iternos -->
		<StationInfo title="Previos internos" :webp="DocsAuthImg" />
		<!-- Station info : Finalización de procesos -->
		<StationInfo title="Finalización de procesos" :webp="ThesisPrintImg" />
	</div>
</template>
