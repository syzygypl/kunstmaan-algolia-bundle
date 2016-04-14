# Kunstmaan Algolia Search

Enable this bundle to index all your pages in [Algolia](http://algolia.com).

## Installation & Configuration

1. `composer require arsthanea/kunstmaan-algolia-bundle`
2. Use `KunstmaanAlgoliaBundle` in your `AppKernel`
3. Configure the Algolia Client

```yaml
# app/config/config.yml

kunstmaan_algolia:
  client:
    app_id: …
    app_secret: …
    public_key: … (optional)
```

## Usage

It just works out of the box. ;) Whenever something is indexed in the default ElasticSearch, it also gets indexed in Algolia.

Use `algolia_settings()` twig function to setup the JS client:

```twig
<script type="text/javascript">
{* algolia_settings will return three keys: id, key and index: *}

  var settings = {{ algolia_settings()|json_encode|raw }};
  var client = algoliasearch(settings.id, settings.key);
  var index = client.initIndex(settings.index);
  …
</script>
```
