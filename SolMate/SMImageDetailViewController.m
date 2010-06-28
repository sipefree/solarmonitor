//
//  SMImageDetailViewController.m
//
//  Created by Simon Free on 14/06/2010.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import "SMImageDetailViewController.h"

@implementation SMImageDetailViewController
@synthesize imageView, scrollView;

- (void)viewDidLoad {
    [super viewDidLoad];
    self.view.backgroundColor = [UIColor viewFlipsideBackgroundColor];      
}

- (void)showImageWithData:(NSDictionary *)dict {
	[loadedImage release];
	loadedImage = [[NSMutableDictionary alloc] init];
	activity.hidden = NO;
	self.imageView.image = nil;
	imageTag = [dict objectForKey:@"type"];
	[loader release];
	loader = [[SMImageLoader alloc] initWithDictionary:loadedImage delegate:self];
	[loader loadImagesFromKeysAndURLs:[NSDictionary dictionaryWithObjectsAndKeys:[NSURL URLWithString:[dict objectForKey:@"fullRes"]],imageTag,nil]];
	NSString* time = [dict objectForKey:@"time"]; 
	titleText.text = time;
}
- (IBAction)back:(id)sender {
    [self.delegate flipsideViewControllerDidFinish:self];
}

- (IBAction)save:(id)sender {
    UIImageWriteToSavedPhotosAlbum(self.imageView.image, nil, nil, nil);
}
- (void)imageLoader:(SMImageLoader*)sender didProgressWithCount:(int)count ofTotal:(int)total {
	UIImage* img = [loadedImage objectForKey:imageTag];
	self.imageView.image = img;
	float ratio = img.size.width/[[UIScreen mainScreen] bounds].size.width;
	CGRect imageFrame = CGRectMake(0,
								   ([[UIScreen mainScreen] bounds].size.height/2)-((img.size.height/ratio)/2),
								   [[UIScreen mainScreen] bounds].size.width, (img.size.height/ratio));
	self.imageView.frame = imageFrame;
	self.imageView.contentMode = UIViewContentModeScaleAspectFit;
	self.imageView.autoresizingMask = ( UIViewAutoresizingFlexibleWidth | UIViewAutoresizingFlexibleHeight);
	scrollView.contentMode = (UIViewContentModeScaleAspectFit);
	scrollView.maximumZoomScale = img.size.width / [[UIScreen mainScreen] bounds].size.width;
	scrollView.minimumZoomScale = 1;
	scrollView.clipsToBounds = YES;
	scrollView.delegate = self;
	activity.hidden = YES;
}

- (UIView *)viewForZoomingInScrollView:(UIScrollView *)scrollView {
	
	return self.imageView;
}

- (void)imageLoaderDidComplete:(SMImageLoader *)sender {
	//[loader release];
}
- (void)dealloc {
	[loader cancel];
	[loader release];
	[activity release];
	[loadedImage release];
	[super dealloc];
}
@end
