<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use RecipeApi\Authenticator;
use RecipeApi\RecipeRepository;
use Slim\Factory\AppFactory;

require 'vendor/autoload.php';

$app = AppFactory::create();

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', '*');
});

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write(file_get_contents('index.html'));
    return $response;
});

$recipesResolver = function(Request $request, Response $response, $args) {
    $repo = new RecipeRepository();
    $params = $request->getParsedBody();

    $response->getBody()->write(json_encode($repo->getFullRecipes(
        (int)($params['offset'] ?? $_REQUEST['offset'] ?? 0),
        (int)($params['limit'] ?? $_REQUEST['limit'] ?? 20)
    )));
   
    return $response;
};

$app->get('/recipes', $recipesResolver);
$app->post('/recipes', $recipesResolver);

$app->post('/recipes/raw', function (Request $request, Response $response, $args) {
    Authenticator::authenticateRequest($request);
    $params = $request->getParsedBody();
    $repo = new RecipeRepository();
    $response->getBody()->write(json_encode($repo->getRecipes(
        (int)($params['offset'] ?? $_REQUEST['offset'] ?? 0),
        (int)($params['limit'] ?? $_REQUEST['limit'] ?? 20)
    )));
    
    return $response;
});

$app->post('/instructions/raw', function (Request $request, Response $response, $args) {
    Authenticator::authenticateRequest($request);
    $repo = new RecipeRepository();
    $ids = json_decode($request->getBody());

    $response->getBody()->write(json_encode($repo->getInstructions($ids)));
    
    return $response;
});

$app->post('/ingredients/raw', function (Request $request, Response $response, $args) {
    Authenticator::authenticateRequest($request);
    $repo = new RecipeRepository();
    $ids = json_decode($request->getBody());
    
    $response->getBody()->write(json_encode($repo->getIngredients($ids)));
    
    return $response;
});

$app->run();
