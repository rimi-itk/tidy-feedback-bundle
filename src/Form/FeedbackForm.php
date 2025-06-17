<?php

namespace ItkDev\TidyFeedbackBundle\Form;

use ItkDev\TidyFeedbackBundle\Entity\FeedbackItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatableMessage;
use Symfony\Contracts\Translation\TranslatableInterface;

class FeedbackForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('subject', TextType::class, [
                'label' => $this->t('Subject'),
                'attr' => [
                    'placeholder' => $this->t('Subject'),
                ],
            ])
            ->add('data', TextareaType::class, [
            ])
            ->add('submit', SubmitType::class, [
                'label' => $this->t('submit'),
            ])
        ;

        $builder->get('data')
            ->addModelTransformer(new CallbackTransformer(
                function (?array $data): string {
                    return json_encode($data ?? (object) []);
                },
                function (string $json): array {
                    try {
                        return json_decode($json, true, flags: JSON_THROW_ON_ERROR);
                    } catch (\JsonException $e) {
                        return [];
                    }
                }
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FeedbackItem::class,
        ]);
    }

    private function t( string $message,         array $parameters = []    ): TranslatableInterface {
        return new TranslatableMessage($message, $parameters, 'TidyFeedback');
    }
}
