<template>
    <div>
        <a v-if="$settings('linkedin')" :href="$settings('linkedin')" target="_blank" rel="external"><linkedin /></a>
        <a v-if="$settings('instagram')" :href="$settings('instagram')" target="_blank" rel="external"><insta /></a>
        <a v-if="$settings('facebook')" :href="$settings('facebook')" target="_blank" rel="external"><fb /></a>
    </div>
</template>

<script>
import fb from "@/static/icons/fb.svg";
import insta from "@/static/icons/insta.svg";
import linkedin from "@/static/icons/linkedin-gray.svg";

export default {
    components: {
        linkedin,
        insta,
        fb,
    },

}
</script>
