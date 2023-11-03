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
    # blurhash generated with 4x4 grid
    ibexa_blurhash.encode.blurhash_width: 4
    ibexa_blurhash.encode.blurhash_height: 4
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

### NOTE
Blurhash generates on image upload, so it will only be available for images uploaded after installation of this bundle.

