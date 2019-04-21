<?php
/**
 * This file is part of the TakeawayDemoApplication package.
 * (c) Ahmad Sajid <ahmadsajid1989@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;


use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Restaurants;
use Swagger\Annotations as SWG;
use JMS\Serializer\SerializationContext;



/**
 * Class RestaurantsController
 * @package AppBundle\Controller
 * @version 0.0.1
 * @author Ahmad Sajid <ahmadsajid1989@gmail.com>
 * @copyright Ahmad Sajid
 * @codeCoverageIgnore
 *
 */
class RestaurantsController extends Controller
{
    /**
     * This method returns the list of restaurants. By default its ordered by openings state
     * Restaurant is either open (top), you can order ahead (middle) or a restaurant is currently closed (bottom)
     * considering 2 is open, 1 you can order ahead and 0 is closed.
     *
     * You can paginate your result by setting offset in the query parameter
     * You can sort your result by best match, newest, rating average, popularity, average product price, delivery costs by adding order_by[best_match]=DESC in the query parameter
     * You can filter restaurant list by name adding filters[name]=The Nightshop in the query parameter
     *
     * @SWG\Tag(
     *     name="Restaurants",
     *     description="List of Restaurants"
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list of restaurants. Restaurant is either open (top), you can order ahead (middle) or a restaurant is currently closed (bottom). considering 2 is open, 1 you can order ahead and 0 is closed.",
     *
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Restaurants::class))
     *     )
     * )
     *
     * @SWG\Response(
     *     response=404,
     *     description="Default error state when requested resource can't be found",
     *
     *
     * )
     *
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     *
     * @param Request $request
     *
     * @return array| Response
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     *
     * @QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing restaurants.")
     * @QueryParam(name="limit", requirements="\d+", default="20", description="How many restaurants to return. Default set to 20")
     * @QueryParam(name="order_by", nullable=true,  description="Order by fields. Must be an array ie. &order_by[best_match]=DESC&order_by[delivery_costs]=DESC")
     * @QueryParam(name="filters", nullable=true,  description="Filter by fields. Must be an array ie. &filters[name]=The Nightshop")
     */

    public function getAction(ParamFetcherInterface $paramFetcher, Request $request)
    {
        $offset = null == $paramFetcher->get('offset') ? 0 : $paramFetcher->get('offset');
        $limit = $paramFetcher->get('limit');
        $order_by_open = array('open' => 'DESC');
        $order_by = null == $paramFetcher->get('order_by') ?  $order_by_open = array('open' => 'DESC') : array_merge($order_by_open,$paramFetcher->get('order_by'));
        $filters = null == $paramFetcher->get('filters') ? [] : $paramFetcher->get('filters');

        try {
            $em = $this->getDoctrine()->getManager();
            $restaurants = $em->getRepository("AppBundle:Restaurants")->findBy($filters, $order_by, $limit, $offset);
        } catch (\Exception $e) {

            return new JsonResponse(['payload'=>['message' =>$e->getMessage(),'code'=> Response::HTTP_BAD_REQUEST]], Response::HTTP_BAD_REQUEST);
        }

        if($restaurants) {
            $version = $request->get('version') =='v5.12.300' ? 1: 1.1;
            $data['payload'] = $restaurants;
            $response = $this->serialize($data,$version);
            return new Response($response, Response::HTTP_OK);
        }

        return new JsonResponse(['payload'=>['message' => 'No restaurant found','code'=> Response::HTTP_NOT_FOUND]], Response::HTTP_NOT_FOUND);
    }

    /**
     * @param $data
     *
     * @return mixed|string
     */
    private function serialize($data,$version)
    {
        return $this->get('jms_serializer')
            ->serialize($data, 'json', SerializationContext::create()->setVersion($version));
    }
}
