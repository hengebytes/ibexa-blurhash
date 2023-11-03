## Installation
```bash
composer require hengebytes/ibexa-blurhash
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

