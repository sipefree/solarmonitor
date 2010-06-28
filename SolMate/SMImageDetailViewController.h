//
//  SMImageDetailViewController.h
//
//  Created by Simon Free on 14/06/2010.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <Foundation/Foundation.h>
#import "SMFlipsideViewController.h"
#import "SMImageLoader.h"

@interface SMImageDetailViewController : SMFlipsideViewController <SMImageLoaderDelegate, UIScrollViewDelegate> {
    IBOutlet UIImageView *imageView;
	IBOutlet UIActivityIndicatorView* activity;
	IBOutlet UIScrollView* scrollView;
	IBOutlet UILabel* titleText;
	NSMutableDictionary *loadedImage;
	NSString *imageTag;
	SMImageLoader* loader;
}
- (void)showImageWithData:(NSDictionary *)dict;
- (IBAction)back:(id)sender;
- (IBAction)save:(id)sender;
@property (nonatomic, assign) UIImageView* imageView;
@property (nonatomic, assign) UIScrollView* scrollView;
@end
