<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Form\PostCreateType;
use App\Service\Management\PostManagementServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use function sprintf;

final class PostController extends AbstractController
{
    /**
     * @param Request $request
     * @param PostManagementServiceInterface $postManagement
     * @return Response
     *
     * @Route("/admin/post/create", name="admin_post_create")
     */
    public function create(Request $request, PostManagementServiceInterface $postManagement)
    {
        $form = $this->createForm(PostCreateType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postData = $form->getData();
            $image = $form->get('image')->getData();

            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                //TODO:: After run project in docker need to install php-intl PHP library for Transliterator to work
                //// this is needed to safely include the file name as part of the URL
                ////                $safeFilename = Transliterator::transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                ////                $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();
                $safeFilename = md5($originalFilename . uniqid());
                $newFilename = $safeFilename . '.' . $image->guessExtension();

                try {
                    $image->move(
                        $this->getParameter('app.images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash(
                        'error',
                        'There was a problem save the image.'
                    );

                    return $this->render('admin/post/create.html.twig', [
                        'form' => $form->createView(),
                    ]);
                }

                $postData->image = $newFilename;
            }

            $post = $postManagement->create($postData);

            $this->addFlash(
                'success',
                sprintf(
                    'Post was successfully created! You can see it by following URL %s',
                    $this->generateUrl('post_view', ['id' => $post->getId()], UrlGeneratorInterface::ABSOLUTE_URL)
                )
            );
            return $this->redirectToRoute('admin_post_create');
        }

        return $this->render('admin/post/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}