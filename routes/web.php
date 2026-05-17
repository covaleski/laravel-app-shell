<?php

app(\Covaleski\LaravelPwa\Services\PwaService::class)
    ->newPwa()
    ->prefixRoutes('pwa')
    ->prefixUri('/app')
    ->setEntrypoint('pwa.entrypoint')
    ->route();
