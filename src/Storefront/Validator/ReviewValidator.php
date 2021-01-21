<?php

namespace Inchoo\ReviewPlugin\Storefront\Validator;

class ReviewValidator
{
    public function validate($data): array
    {
        $errors = [];
        $title = $data['title'];
        $reviewText = $data['reviewText'];
        $rating = $data['rating'];

        if(!is_string($title) || strlen($title) > 255 || ctype_space($title))
        {
            $errors['title'] = "Title must be a non empty string shorter than 256 characters";
        }

        if(!is_string($reviewText) || strlen($reviewText) > 4294967295 || ctype_space($reviewText))
        {
            $errors['reviewText'] = "Text must be a non empty string shorter than 4294967295 characters";
        }

        if(!is_numeric($rating) || $rating < 1 || $rating > 10)
        {
            $errors['rating'] = "Rating must be and integer between 1 and 10";
        }

        return $errors;
    }
}