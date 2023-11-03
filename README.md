## Installation
```bash
composer require hengebytes/ibexa-blurhash
```

### (Optional) configure image transformation
```yaml
# config/packages/ibexa_blurhash.yaml
parameters:
    # uploaded image resized to 75x75 before encoding
    ibexa_blurhash.encode.resize_original_width: 75
    ibexa_blurhash.encode.resize_original_height: 75
    # blurhash generated with 4x3 component, x and y component counts must be between 1 and 9 inclusive.
    ibexa_blurhash.encode.blurhash_x_count: 4
    ibexa_blurhash.encode.blurhash_y_count: 3
```

### Query blurhash data in GraphQL. 
```graphql
query {
  media {
    image(contentId: 19) {
      image {
        uri
        additionalData {
          blurhash
        }
      }
    }
  }
}
```

### Decode in browser
- [TypeScript](./docs/TypeScript.md)
- [React](./docs/React.md)


### NOTE
Blurhash generates on image upload, so it will only be available for images uploaded after installation of this bundle.

## Credits
- Algorithm authors - [blurha.sh](https://blurha.sh/)
- Inspired by [symfony/ux-lazy-image](https://github.com/symfony/ux-lazy-image)
