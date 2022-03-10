<template>
	<div class="services-inner-tab">
		<div class="services-inner-content">
			<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quae excepturi iusto facere nisi doloremque quis, laboriosam, fuga natus alias debitis aliquid, maiores omnis molestias quas tempore quaerat voluptates officiis similique.</p>
			<br>
			<p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Consequuntur necessitatibus quo odio minima culpa, laudantium provident! Fugiat itaque architecto tempora ipsam? Iste quibusdam quis repudiandae! Fuga aliquam numquam necessitatibus voluptatibus?</p>
			<br>
			<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic amet impedit velit nesciunt, commodi obcaecati quis aperiam aut? Beatae magnam exercitationem omnis dicta ipsa animi praesentium? Quaerat aut et exercitationem!</p>
		</div>
		<aside class="services-inner-aside">
			<button class="button --red">Запросить коммерческое предложение</button>
			<a href="" class="services-inner-file">
				<pdf-icon />
				Политика АО «ASTEL» в области ИСМ
			</a>
			<div class="services-inner-divider"></div>
			<a href="" class="services-inner-download-link">Прейскурант оператора на услуги телефонной связи действующий c 01.07.2020</a>
		</aside>
	</div>
</template>
<script>
import pdfIcon from "@/static/icons/pdf.svg";
export default {
	components: {
		pdfIcon,
	},
};
</script>
