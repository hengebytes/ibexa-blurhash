# React Component Example for 

#### Check [TypeScript.md](./TypeScript.md) for `@/blurhash` implementation

```tsx
import Image, { ImageProps } from "next/image";
import blurHashToDataURL from "@/blurhash";
import { useMemo } from "react";

interface IProps extends Partial<ImageProps> {
  image?: {
    uri: string;
    alternativeText?: string;
    additionalData?: {
      blurhash?: string;
    };
  };
  hashWidth?: number;
  hashHeight?: number;
}

export function CMSImage({ image, hashWidth, hashHeight, ...props }: IProps) {
  if (!image?.uri) {
    return null;
  }

  const calculatedProps: ImageProps = {
    src: fixRelativeUrl(image.uri),
    alt: image.alternativeText || image.uri.split('/').pop() || '',
  };

  const blurDataURL = useMemo(() => {
    const width = hashWidth || props.width || 500;
    const height = hashHeight || props.height || 500;

    return image.additionalData?.blurhash
      ? blurHashToDataURL(image.additionalData.blurhash, +width, +height)
      : undefined;
  }, [image.additionalData?.blurhash, hashWidth, props.width, hashHeight, props.height]);

  if (blurDataURL) {
    calculatedProps.placeholder = 'blur';
    calculatedProps.blurDataURL = blurDataURL;
  }

  return (
    <Image
      {...calculatedProps}
      {...props}
      className={`${props.className || ''}${props.fill ? ' object-center object-cover h-full w-full' : ''}` || undefined}
    />
  );
}
```