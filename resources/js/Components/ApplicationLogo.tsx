import { DetailedHTMLProps, ImgHTMLAttributes, SVGAttributes } from 'react';

export default function ApplicationLogo(
    props: DetailedHTMLProps<ImgHTMLAttributes<HTMLImageElement>, HTMLImageElement>
) {
    return <img {...props} alt="UPEI HSE" src="/images/upei.png" />;
}
