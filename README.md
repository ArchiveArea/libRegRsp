# libRegRsp
Resource pack register library for PocketMine plugins

## API documentation
There's no documentation yet, but you can check out the [demo plugin](https://github.com/nhanaz-pm-pl/CustomJoinSound/) which shows how to use its API in a plugin.

## Including in other plugins
This library supports being included as a [virion](https://github.com/poggit/support/blob/master/virion.md).

If you use [Poggit](https://poggit.pmmp.io) to build your plugin, you can add it to your `.poggit.yml` like so:

```yml
projects:
  YourPlugin:
    libs:
      - src: nhanaz/libRegRsp/libRegRsp
        version: ^1.0.0
```