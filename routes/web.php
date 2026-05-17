<?php

(new \Covaleski\LaravelPwa\Routing\Router())
    ->prefixRoutes('pwa')
    ->prefixUri('/app')
    ->setEntrypoint('pwa.entrypoint')
    ->route();
